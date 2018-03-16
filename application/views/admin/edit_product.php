<div class="container">
<br>

    <h1>O produkcie</h1>

    <!--  O produkcie  -->
    <?php echo form_open('admin/editproduct/' . $product['id']); ?>
    <table class="table">

        <thead>
        <tr>
            <th scope="col">Id produktu</th>
            <th scope="col">Nazwa produktu</th>
            <th scope="col">Najwyższa oferta</th>
            <th scope="col">Opcje</th>
        </tr>
        </thead>

        <tbody>

            <tr>
                <td><?php echo $product['id']; ?></td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" name="product_name" value="<?php echo $product['name']; ?>"/>
                    </div>
                </td>
                <td><?php echo $max_price/100; ?></td>
                <?php $hrefDelete = base_url().'index.php/admin/deleteproduct/'.$product['id']; ?>
                <td>
                    <input type="submit" class="btn btn-primary text-right btn-sm" value="Zapisz zmiany!">
                    <a href='<?php echo $hrefDelete ?>' class='btn btn-danger btn-sm'>Usuń przedmiot</a>
                </td>
            </tr>

        </tbody>

    </table>

    <?php echo form_close(); ?>

    <br>
    <h4>Idź do <a href="<?php echo base_url().'index.php/admin/product/'.$product['id']; ?>" class="btn btn-success btn-sm">Dodaj</a></h4>
    <p>

    <h2>Licytacje</h2>
    <table class="table">

        <thead>
        <tr>
            <th scope="col">Id licytującego</th>
            <th scope="col">Kwota</th>
            <th scope="col">Akcja</th>
        </tr>
        </thead>

        <tbody>

            <?php
            foreach ($prices as $price):
                $hrefDelete = base_url().'index.php/admin/deletebid/'.$price['id'].'/'.$price['product_id'];
                $hrefEdit = base_url().'index.php/admin/editbid/'.$product['id'];

                echo form_open('admin/editbid/' . $product['id']);

                echo '<input type="hidden" name="id" value="'. $price['id'] .'"/>';

                echo "<tr>";
                echo '<td>
                            <div class="form-group">
                                <input type="text" class="form-control" name="bidder_id" value="' . $price['bidder_id'] .
                            '"/></div>
                      </td>';
                echo '<td>
                            <div class="form-group">
                                <input type="text" class="form-control" name="price" value="' . $price['price']/100 .
                    '"/></div>
                      </td>';

                echo '<td>    <input type="submit" class="btn btn-primary btn-sm text-right" value="Zapisz zmiany!">';
                echo "<a href='$hrefDelete' class='btn btn-danger btn-sm'>Usuń</a> </td>";
                echo "</tr>";

                echo form_close();

            endforeach;
            ?>

        </tbody>

    </table>