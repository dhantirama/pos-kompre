let addRow = document.getElementById("add-row");
addRow.addEventListener("click", function () {
  let table = document.getElementById("table").getElementsByTagName("tbody")[0];
  let newRow = table.insertRow(table.rows.length);

  // untuk membuat table row
  let namaPaketCell = newRow.insertCell(0);
  let paketId = document.getElementById("id_paket").value;
  if (paketId == "") {
    alert("Paket tidak boleh kosong");
    return false;
  }

  
  // Ambil harga paket dari server menggunakan AJAX (contoh sederhana menggunakan fetch)
  fetch(`getHarga.php?id=${paketId}`)
    .then(response => response.json())
    .then(data => {
      let price = data.price;
      priceInput.value = price;  // Set price ke kolom price
  
      // Update subtotal
      qtyInput.addEventListener('change', function() {
        let qty = parseInt(qtyInput.value) || 0;
        let subtotal = qty * price;
        subtotalInput.value = subtotal;
      });
    });
  
