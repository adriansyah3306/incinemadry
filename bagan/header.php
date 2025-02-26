<?php
session_start();
?>

<header>
    <div class="logo">
        <img src="assets/img/logo_incinema.png" alt="Logo">
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="coming_soon.php">Upcoming</a></li>
            <li><a href="theater.php">Teater</a></li>
            <li class="dropdown">
                <a href="#">Usia &#9660;</a>
                <div class="dropdown-content">
                    <a href="usia.php?usia=13" class="dropdown-item">13+</a>
                    <a href="usia.php?usia=17" class="dropdown-item">17+</a>
                    <a href="usia.php?usia=SU" class="dropdown-item">SU</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Genre &#9660;</a>
                <div class="dropdown-content">
                <a href="genre.php?genre=Action">Action</a>
                    <a href="genre.php?genre=Adventure">Adventure</a>
                    <a href="genre.php?genre=Animation">Animation</a>
                    <a href="genre.php?genre=Biography">Biography</a>
                    <a href="genre.php?genre=Comedy">Comedy</a>
                    <a href="genre.php?genre=Crime">Crime</a>
                    <a href="genre.php?genre=Documentary">Documentary</a>
                    <a href="genre.php?genre=Drama">Drama</a>
                    <a href="genre.php?genre=Fantasy">Fantasy</a>
                    <a href="genre.php?genre=Horror">Horror</a>
                    <a href="genre.php?genre=Romance">Romance</a>
                    <a href="genre.php?genre=Sci-Fi">Sci-Fi</a>
                    <a href="genre.php?genre=Thriller">Thriller</a>
                    <a href="genre.php?genre=War">War</a>
                    <a href="genre.php?genre=Western">Western</a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="search-login">
        <div class="search-container">
            <input type="text" id="searchMovie" placeholder="Search..." class="search-input">
            <ul id="movieResults" class="search-results hidden"></ul>
        </div>
        
        <nav>
            <ul>
                <li class="dropdown">
                    <?php if(isset($_SESSION['name'])): ?>
                        <button class="login-btn"><?php echo $_SESSION['name']; ?> &#9660;</button>
                        <div class="dropdown-content">
                            <a href="riwayat.php?username=<?php echo $_SESSION['email']; ?>">Riwayat Transaksi</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="login-btn">Login/Register</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</header>

<style>
   .search-login {
    display: flex;
    align-items: center;
    gap: 20px; /* Memberikan jarak antara search dan bar admin */
}

.search-container {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 250px;
    margin-right: 20px; /* Memberikan jarak dari bar admin */
}

.search-input {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 100%;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #333; /* Warna gelap */
    color: white; /* Warna teks putih */
    border: 1px solid #555;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    list-style: none;
    padding: 0;
    margin: 5px 0 0;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
}

.search-results li {
    padding: 10px;
    cursor: pointer;
    transition: background 0.3s;
}

.search-results li:hover {
    background-color: #C09A7F;
    color: white;
}

.hidden {
    display: none;
}
</style>

<script>
    const searchInput = document.getElementById("searchMovie");
    const resultsList = document.getElementById("movieResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        resultsList.innerHTML = "";
        
        if (query.length > 0) {
            fetch(`get_movies.php?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsList.classList.toggle("hidden", data.length === 0);
                    resultsList.innerHTML = ""; 

                    data.forEach(movie => {
                        const li = document.createElement("li");
                        li.textContent = movie.nama_film;
                        li.className = "p-2 hover:bg-pink-500 text-black cursor-pointer transition-all duration-200";

                        li.onclick = () => {
                            window.location.href = `lihat_film.php?id=${movie.id}`;
                        };

                        resultsList.appendChild(li);
                    });
                })
                .catch(error => console.error("Error fetching data:", error));
        } else {
            resultsList.classList.add("hidden");
        }
    });

    // Sembunyikan dropdown kalau klik di luar
    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !resultsList.contains(e.target)) {
            resultsList.classList.add("hidden");
        }
    });
</script>