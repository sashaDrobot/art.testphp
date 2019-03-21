<form class="w-100 m-auto" id="registration" method="post" action="getRegions">
    <div class="form-group">
        <input type="text" name="name" id="name" class="form-control" placeholder="ФИО" required>
    </div>
    <div class="form-group">
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="form-group">
        <select class="form-control chosen-select" id="regionList" name="region" required>
            <option value="" selected disabled>Select region...</option>
            <?php foreach ($data['regions'] as $item) { ?>
                <option value="<?= $item['region'] ?>"><?= $item['region'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group" id="areaListContainer">
        <select class="form-control chosen-select" id="areaList" name="area" required></select>
    </div>
    <div class="form-group" id="cityListContainer">
        <select class="form-control chosen-select" id="cityList" name="city" required></select>
    </div>
    <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
</form>
