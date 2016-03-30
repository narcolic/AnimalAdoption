<div class="jumbotron">
    <div class="container">
        <table class="table">
            <caption>
                <h2 class="table title">Animal for Adoption</h2>
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
                <td><?php echo $animal->name; ?></td>
                <td><?php echo $animal->birthdate; ?></td>
                <td><?php echo $animal->description; ?></td>
                <td><?php echo $animal->picture; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <form class="form" action="index.php?action=home" method="post">
            <div class="form-group">
                Name:
                <input name="animal_name" type="text" class="form-control" placeholder="name">
                Date:
                <input name="animal_date" type="date" class="form-control" placeholder="date">
                Description:
                <input name="animal_description" type="text" class="form-control" placeholder="description">
                Photo:
                <input name="animal_photo" type="text" class="form-control" placeholder="photo">
                <input name="add_animal" type="hidden" value="1">
            </div>
            <button class="btn btn-success" type="submit">Add Animal</button>
        </form>
        <table class="table">
            <caption>
                <h2 class="table title">Animals & Owners</h2>
            </caption>
            <tr>
                <th>Username</th>
                <th>Animal Name</th>
                <th>Animal Birth Date</th>
                <th>Description</th>
                <th>Photo</th>
            </tr>
            <?php foreach ($this->page->model['AnimalOwners'] as $ownsRequest):?>
                <tr>
                    <td><?php echo $ownsRequest->uname; ?></td>
                    <td><?php echo $ownsRequest->aname; ?></td>
                    <td><?php echo $ownsRequest->birthdate; ?></td>
                    <td><?php echo $ownsRequest->description; ?></td>
                    <td><?php echo $ownsRequest->picture; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>

        <table class="table">
            <caption>
                <h2 class="table title">Pending Adoption Requests</h2>
            </caption>
            <tr>
                <th>Adoption ID</th>
                <th>Username</th>
                <th>Animal Name</th>
                <th>Animal Birth Date</th>
                <th>Description</th>
                <th>Photo</th>
            </tr>
            <?php foreach ($this->page->model['AdoptionRequests'] as $adoptionRequest):?>
                <tr>
                    <td><?php echo $adoptionRequest->adid; ?></td>
                    <td><?php echo $adoptionRequest->uname; ?></td>
                    <td><?php echo $adoptionRequest->aname; ?></td>
                    <td><?php echo $adoptionRequest->birthdate; ?></td>
                    <td><?php echo $adoptionRequest->description; ?></td>
                    <td><?php echo $adoptionRequest->picture; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>