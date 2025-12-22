# Documents Directory

This directory contains downloadable documents (PDFs) that are listed on the website.

## How to Add Documents

1. Place your PDF files in this directory (e.g., `jahresbericht-2024.pdf`)
2. Add an entry to `/data/documents.json` with the following structure:

```json
{
  "title": "Document Title",
  "description": "Brief description of the document",
  "filename": "filename-in-this-directory.pdf",
  "order": 1,
  "category": "Category Name",
  "visible": true
}
```

## Fields Explained

- **title**: Display name shown on the website
- **description**: Short description shown below the title
- **filename**: Actual filename in this directory (must be .pdf)
- **order**: Display order (lower numbers appear first)
- **category**: Optional category for grouping
- **visible**: Set to `false` to hide a document without deleting it

## Security

- Only PDF files are allowed
- Filenames must contain only alphanumeric characters, hyphens, and underscores
- Files are served through a secure download handler
