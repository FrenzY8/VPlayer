const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware untuk melayani file statis (HTML, CSS, JS)
app.use(express.static(path.join(__dirname, 'public')));

// Parsing body untuk menerima form data (dalam hal ini digunakan untuk upload)
app.use(express.urlencoded({ extended: true }));

// Route untuk mengunggah video (dari admin)
app.post('/upload.php', (req, res) => {
  const { title, url, thumbnail } = req.body;

  // Path ke uploads.json
  const jsonFilePath = path.join(__dirname, 'public', 'uploads.json');

  // Memuat data JSON yang ada
  let uploads = [];
  if (fs.existsSync(jsonFilePath)) {
    const data = fs.readFileSync(jsonFilePath, 'utf8');
    uploads = JSON.parse(data);
  }

  // Fungsi untuk membuat ID acak
  const generateRandomId = (length = 8) => {
    return Math.random().toString(36).substr(2, length);
  };

  // Tambahkan video baru dengan ID acak
  const newVideo = {
    id: generateRandomId(),
    title,
    url,
    thumbnail: thumbnail || 'default-thumbnail.jpg'
  };

  uploads.push(newVideo);

  // Tulis ulang file JSON dengan data terbaru
  fs.writeFileSync(jsonFilePath, JSON.stringify(uploads, null, 2));

  // Redirect kembali ke halaman admin setelah berhasil upload
  res.redirect('/index.html');
});


// Jalankan server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
