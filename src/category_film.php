<?php include "top.php"; ?>
<!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->
<nav>
  <p><a href="film.php">Volver</a></p>
</nav>
<section id="films">
  <h2>Categorías de la pelicula: Nombre de la película</h2>
  <form action="category_film.php" action="post">
    
    <ul>
      <?php
      $sql = "SELECT name FROM category";
      $result = $link->query($sql);
      $category = $result->fetch_assoc();
      while ($category != null) {
        $name = $category['name'];
      ?>
        <li>
          <label>
            <input type="checkbox" name="" id="">
            <?= $name ?>
          </label>
        </li>
      <?php
        $category = $result->fetch_assoc();
      }
      $result->close();
      ?>
<?php
      if (isset($_GET['id']) && isset($_POST['update'])) {
        $filmId = $_GET['id'];
        $sqlDelete = "DELETE FROM film_category WHERE film_id = $filmId";
        $link->query($sqlDelete);

        if (isset($_POST['categories']) && is_array($_POST['categories'])) {
          foreach ($_POST['categories'] as $selectedCategory) {
            $selectedCategory = $link->real_escape_string($selectedCategory);

            $sqlInsert = "INSERT INTO film_category (film_id, category_id) 
            VALUES ($filmId, (SELECT category_id FROM category WHERE name = '$selectedCategory'))";

            $link->query($sqlInsert);
          }
        }
        echo "<p>Se han actualizado las categorías de la película.</p>";
      }
      ?>
     

      <!-- ESTO NO ES NECESARIO -->
      <!-- <li>
        <label>
          <input type="checkbox" name="" id="">
          Acción
        </label>
      </li>
      <li>
        <label>
          <input type="checkbox" name="" id="">
          Comedia
        </label>
      </li>
      <li>
        <label>
          <input type="checkbox" name="" id="">
          Misterio
        </label>
      </li> -->
    </ul>
    <p>
      <input type="submit" value="Actualizar">
    </p>
  </form>
  <section>
    <?php include "bottom.php"; ?>