<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Вы вошли</h1>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $data['userName']; ?></h5>
            <p class="card-text"><?php echo $data['userEmail']; ?></p>
            <p class="card-text"><?php echo $data['userTerritory']; ?></p>
            <a href="logout" class="btn btn-primary">Log out</a>
        </div>
    </div>
</div>
