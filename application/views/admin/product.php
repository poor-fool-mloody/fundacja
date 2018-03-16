<div class="container">
<br>

<!--  O produkcie  -->
    <table class="table">

        <thead>
        <tr>
            <th scope="col">Id produktu</th>
            <th scope="col">Nazwa produktu</th>
            <th scope="col">Najwyższa oferta</th>
<!--            <th scope="col">Opcje</th>-->
        </tr>
        </thead>

        <tbody>

        <?php
            echo "<tr>";
            echo "<td>" . $product['id'] . "</td>";
            echo "<td>" . $product['name'] . "</td>";
            echo "<td>" . $max_price/100 . "</td>";
//            echo "<td> #Edytuj | #Usuń </td>";
            echo "</tr>";
        ?>

        </tbody>

    </table>

    <br>
    <h4>Idź do <a href="<?php echo base_url().'index.php/admin/editproduct/'.$product['id']; ?>" class="btn btn-warning btn-sm">Edytuj</a></h4>
	<br>
    <h4>Aktywuj zdjęcie <a href="<?php echo base_url().'index.php/photos/setphoto/'.$product['id']; ?>" class="btn btn-secondary btn-sm">Aktywuj</a></h4>
    <br><br>

<!--    Licytacje!-->

    <div class="row">
        <div class="col">
            <!--  Kwoty  -->
            <h4><p style="color: #2986ff;">Licytacje</p></h4>
            <table class="table">

                <thead>
                <tr>
                    <th scope="col">Id licytującego</th>
                    <th scope="col">Kwota</th>
                    <!--                <th scope="col">Najwyższa oferta</th>-->
                    <!--                    <th scope="col">Opcje</th>-->
                </tr>
                </thead>

                <tbody>

                <?php
                foreach ($prices as $price):
                    echo "<tr>";
                    echo "<td>" . $price['bidder_id'] . "</td>";
                    echo "<td>" . $price['price']/100 . "</td>";
//                    echo "<td> #Usuń </td>";
                    echo "</tr>";
                endforeach;
                ?>

                </tbody>

            </table>
        </div>
        <div class="col">
<!--            Formularz dodawania nowej kwoty-->
            <h4><p style="color: #2986ff;">Dodaj nową ofertę</p></h4>

            <?php echo form_open('admin/addprice/'.$product['id']); ?>
            <div class="form-group">
                <label for="bidder_id">Numer licytującego</label>
                <input class="form-control text-center" name="bidder_id">
            </div>
            <div class="form-group">
                <label for="pirce">Kwota</label>
                <input class="form-control text-center" name="price">
            </div>
            <input type="submit" class="btn btn-success" value="Dodaj">
            <?php echo form_close(); ?>

        </div>
    </div>