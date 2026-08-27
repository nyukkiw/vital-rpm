<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-add User</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <div class="title-addUser">
                    <H1>Tambah user</H1>
                </div>
            </header>
            <main>
                <div class="formAdd-container">
                <form method="POST" action="function/data_handle.php">
                    <input type="text" name="userName" placeholder="Nama pengguna">
                    <input type="password" name="password" placeholder="Password">

                    <input type="radio" name="laki" placeholder="Nama pengguna">
                    <input type="radio" name="parempuan" placeholder="Nama pengguna">

                    <input type="text" name="alamat" placeholder="Nama pengguna">
                    <input type="password" name="alergi" placeholder="Password">

                    <input type="text" name="peran" placeholder="Nama pengguna">
                    <input type="password" name="noRekamMedis" placeholder="Password">

                    <input type="text" name="umur" placeholder="Nama pengguna">
                    <input type="password" name="noTlpn" placeholder="Password">

                    <input type="password" name="noTlpn" placeholder="Password">

                    <button type="submit" id="daftarButton">Daftarkan</button>
                </form>   
                </div>
            </main>

        </div>
    </div>

</body>
</html>