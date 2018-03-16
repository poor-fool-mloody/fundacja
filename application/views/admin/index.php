<div class="container">
<br>

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

        <?php
            foreach ($products as $product):
                echo "<tr>";
                echo "<td>" . $product['id'] . "</td>";
                echo "<td>" . $product['name'] . "</td>";
                echo "<td>" . $product['max_price']/100 . "</td>";
                $hrefAdd = base_url().'index.php/admin/product/'.$product['id'];
                $hrefEdit = base_url().'index.php/admin/editproduct/'.$product['id'];
                echo "<td> 
                        <a href='$hrefAdd' class='btn btn-success btn-sm'>Dodaj licytacje</a>
                        <a href='$hrefEdit' class='btn btn-warning btn-sm'>Edytuj produkt</a>
                        </td>";
                echo "</tr>";
            endforeach;
        ?>

        </tbody>

    </table>

</div>