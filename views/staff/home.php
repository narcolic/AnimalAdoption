<div class="jumbotron">
    <div class="container">
        <table class="table">
            <caption>
                <h2 class="table title">Animal for adoption</h2>
            </caption>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Photo</th>
            </tr>
            <?php foreach ($this->page->model['Animals'] as $animal):?>
            <tr>
                <td><?php echo $animal->id; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>