<?php
/**
 * SMTP Email Client
 * Simple SMTP implementation without external dependencies
 */

class SMTPClient {
    private $host;
    private $port;
    private $username;
    private $password;
    private $timeout;
    private $socket;
    
    public function __construct($host, $port, $username, $password, $timeout = 30) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->timeout = $timeout;
    }
    
    public function send($from, $fromName, $to, $subject, $body, $replyTo = null, $cc = null, $isHtml = false) {
        try {
            $this->connect();
            $this->authenticate();
            $this->sendMail($from, $fromName, $to, $subject, $body, $replyTo, $cc, $isHtml);
            $this->disconnect();
            return true;
        } catch (Exception $e) {
            $this->disconnect();
            throw $e;
        }
    }
    
    private function connect() {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $this->socket = @stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $errno, $errstr, $this->timeout, STREAM_CLIENT_CONNECT, $context
        );
        
        if (!$this->socket) {
            throw new Exception("Failed to connect to SMTP server: {$this->host}:{$this->port} - {$errstr} ({$errno})");
        }
        
        $response = $this->readResponse();
        if (substr($response, 0, 3) !== '220') {
            throw new Exception("SMTP connection failed: {$response}");
        }
        
        $this->sendCommand("EHLO {$this->host}");
        
        // Start TLS if port 587
        if ($this->port == 587) {
            $this->sendCommand("STARTTLS");
            if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("Failed to enable TLS encryption");
            }
            $this->sendCommand("EHLO {$this->host}");
        }
    }
    
    private function authenticate() {
        $this->sendCommand("AUTH LOGIN", ['334']);
        $this->sendCommand(base64_encode($this->username), ['334']);
        $this->sendCommand(base64_encode($this->password), ['235']);
    }
    
    private function sendMail($from, $fromName, $to, $subject, $body, $replyTo, $cc = null, $isHtml = false) {
        $this->sendCommand("MAIL FROM:<{$from}>");
        $this->sendCommand("RCPT TO:<{$to}>");
        
        if ($cc) {
            $this->sendCommand("RCPT TO:<{$cc}>");
        }
        
        $this->sendCommand("DATA");
        
        $headers = [];
        $headers[] = "From: {$fromName} <{$from}>";
        $headers[] = "To: {$to}";
        if ($cc) {
            $headers[] = "CC: {$cc}";
        }
        if ($replyTo) {
            $headers[] = "Reply-To: {$replyTo}";
        }
        $headers[] = "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=";
        $headers[] = "Date: " . date('r');
        $headers[] = "MIME-Version: 1.0";
        
        if ($isHtml) {
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }
        
        $headers[] = "Content-Transfer-Encoding: 8bit";
        $headers[] = "X-Mailer: Anpa-Stiftung-SMTP/1.0";
        $headers[] = "";
        
        $processedBody = "\r\n" . $this->processEmailBody($body);
        $email = implode("\r\n", $headers) . $processedBody . "\r\n.";
        
        fwrite($this->socket, $email . "\r\n");
        
        $response = $this->readResponse();
        if (substr($response, 0, 3) !== '250') {
            throw new Exception("Failed to send email data: {$response}");
        }
        
        $this->sendCommand("QUIT");
    }
    
    private function processEmailBody($body) {
        if (!mb_check_encoding($body, 'UTF-8')) {
            $body = mb_convert_encoding($body, 'UTF-8', 'auto');
        }
        
        $lines = explode("\n", $body);
        $processedLines = [];
        
        foreach ($lines as $line) {
            $line = rtrim($line, "\r");
            
            if (strlen($line) <= 998) {
                $processedLines[] = $line;
            } else {
                $chunks = str_split($line, 990);
                foreach ($chunks as $i => $chunk) {
                    if ($i > 0) {
                        $chunk = ' ' . $chunk;
                    }
                    $processedLines[] = $chunk;
                }
            }
        }
        
        return implode("\r\n", $processedLines);
    }
    
    private function sendCommand($command, $expectedCodes = null) {
        fwrite($this->socket, $command . "\r\n");
        $response = $this->readResponse();
        
        $successCodes = $expectedCodes ?: ['220', '221', '235', '250', '354'];
        $responseCode = substr($response, 0, 3);
        
        if (!in_array($responseCode, $successCodes)) {
            throw new Exception("SMTP command failed: {$command} -> {$response}");
        }
        
        return $response;
    }
    
    private function readResponse() {
        $response = '';
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') {
                break;
            }
        }
        return trim($response);
    }
    
    private function disconnect() {
        if ($this->socket) {
            fclose($this->socket);
            $this->socket = null;
        }
    }
}
?>
