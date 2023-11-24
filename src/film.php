<?php include "top.php"; ?>
<!--
    <div class="alert alert-success">¡Ejemplo mensaje de éxito!</div>
    <div class="alert alert-error">¡Ejemplo mensaje de error!</div>
    -->

<section id="films">
    <h2>Peliculas</h2>
    <form action="film.php" method="get">
        <fieldset>
            <legend>Categorías</legend>
            <select name="category">
                <option selected disabled>Elige una categoría</option>

                <?php

                $sql = 'SELECT * FROM category;';
                $result = $link->query($sql);
                $category = $result->fetch_assoc();

                while ($category !== null) {
                    $id = $category['category_id'];
                    $name = $category['name']; ?>

                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php
                    $category = $result->fetch_assoc();
                }
                $result->close();
                ?>
            </select>
            <input type="submit" name="search" value="buscar">
            <input type="submit" name="delete" value="eliminar">
        </fieldset>
        

    </form>
    <?php
                if (isset($_GET['delete'])) {
                    $id = $_GET['category'];
                    try {
                        $sql = "DELETE FROM `category` WHERE `category`.`category_id` = $id; ";
                        $result = $link->query($sql);
                        if ($result) {
                            echo "<p>Se ha eliminado la categoria exitosamente.</p>";
                        }
                    } catch (Exception $e) {
                        // echo 'Excepción capturada: ', $e->getMessage(), "\n";
                        echo "<h3>Error al eliminar, debe quitar la categoria de las peliculas asociadas a la misma</h3>";
                    }
                };
                ?>

    <nav>
        <fieldset>
            <legend>Acciones</legend>
            <a href="create.php">
                <button>Crear Categoria</button>
            </a>
        </fieldset>
    </nav>
    <?php
    if (isset($_GET['category']) && isset($_GET['search'])) {
        $id = $_GET['category'];
        $sql = "SELECT film.film_id, film.title, film.release_year, film.length FROM film, film_category    
                WHERE film.film_id = film_category.film_id AND film_category.category_id = $id;";
        $result = $link->query($sql);
        $film = $result->fetch_assoc();
        if ($film == null) {
            echo '<h3>No hay peliculas en esta categoria</h3>';
        } else {
    ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Año</th>
                        <th>Duración</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($film !== null) {
                        $id = $film['film_id'];
                        $title = $film['title'];
                        $year = $film['release_year'];
                        $duration = $film['length'];
                    ?>

                        <tr>
                            <td><?= $title ?></td>
                            <td class="center"><?= $year ?></td>
                            <td class="center"><?= $duration ?></td>
                            <td class="actions">
                                <a class="button" href="category_film.php?id=<?= $id ?>">
                                    <button>Cambiar categorías</button>
                                </a>
                            </td>
                        </tr>
            <?php
                        $film = $result->fetch_assoc();
                    }
                    $result->close();
                }
            } ?>
                </tbody>
            </table>
</section>
<?php include "bottom.php"; ?>