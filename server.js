const express = require('express');
const mysql = require('mysql');
const PDFDocument = require('pdfkit');
const XLSX = require('xlsx');
const fs = require('fs');
const app = express();
const port = 3000;

// MySQL Database Connection
require_once("includes/config.php");


// Generate PDF
app.get('/download/pdf', (req, res) => {
  const query = 'SELECT * FROM clients'; // Replace with your table name
  db.query(query, (err, results) => {
    if (err) throw err;

    const doc = new PDFDocument();
    const filePath = './output/sample.pdf';

    doc.pipe(fs.createWriteStream(filePath));

    doc.fontSize(16).text('Data from Database', { underline: true });
    doc.moveDown();

    results.forEach((row, index) => {
      doc.fontSize(12).text(`${index + 1}. ${JSON.stringify(row)}`);
    });

    doc.end();

    res.download(filePath, 'sample.pdf', () => {
      fs.unlinkSync(filePath); // Clean up file after download
    });
  });
});

// Generate Excel
app.get('/download/excel', (req, res) => {
  const query = 'SELECT * FROM clients'; // Replace with your table name
  db.query(query, (err, results) => {
    if (err) throw err;

    const worksheet = XLSX.utils.json_to_sheet(results);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

    const filePath = './output/sample.xlsx';
    XLSX.writeFile(workbook, filePath);

    res.download(filePath, 'sample.xlsx', () => {
      fs.unlinkSync(filePath); // Clean up file after download
    });
  });
});

// Start Server
app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
