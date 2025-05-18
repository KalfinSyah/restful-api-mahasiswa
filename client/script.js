document.addEventListener('DOMContentLoaded', () => {
  const contentSection = document.getElementById('content');

  fetch('http://localhost:8000/mahasiswa')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(result => {
      const mahasiswaList = result.data;

      if (mahasiswaList.length === 0) {
        contentSection.innerHTML += '<p>No mahasiswa found.</p>';
        return;
      }

      const ul = document.createElement('ul');
      mahasiswaList.forEach(m => {
        const li = document.createElement('li');
        li.textContent = `Nama: ${m.nama}, NPM: ${m.npm}, Angkatan: ${m.angkatan}, IPK: ${m.ipk}`;
        ul.appendChild(li);
      });
      contentSection.appendChild(ul);
    })
    .catch(error => {
      console.error('Fetch error:', error);
    });
});
