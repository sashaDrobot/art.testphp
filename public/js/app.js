$(document).ready(function () {
    $('#registration').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                pattern: "^[\\sA-Za-zА-Яа-яЁёіЇї\-]+$"
            },
            email: {
                required: true,
                minlength: 5,
            },
            region: {
                required: true
            },
            area: {
                required: true
            },
            city: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Поле 'ФИО' обязательно к заполнению",
                minlength: "Введите не менее 3-х символов в поле 'Имя'",
                pattern: 'Могут быть только буквы, пробелы и -'
            },
            email: {
                required: "Поле 'Email' обязательно к заполнению",
                email: "Необходим формат адреса email"
            },
            region: {
                required: "Поле 'Область' обязательно к заполнению"
            },
            area: {
                required: "Поле 'Район' обязательно к заполнению"
            },
            city: {
                required: "Поле 'Город' обязательно к заполнению"
            }
        }
    });

    $(".chosen-select").chosen({required: true});

    $('#regionList').change(function () {
        $.ajax({
            type: 'post',
            url: 'getAreas',
            data: 'region=' + $('#regionList').val(),
            dataType: 'json',
            success: function (result) {
                let html = '';
                for (let i = 0; i < result.length; i++) {
                    html += `<option>${result[i]['area'].trim()}</option>`;
                }
                $('#areaList').html(html).trigger("chosen:updated");
                $('#areaListContainer').css('opacity', '1');
            },
        });
    });

    $('#areaList').change(function () {
        $.ajax({
            type: 'post',
            url: 'getCities',
            data: 'area=' + $('#areaList').val(),
            dataType: 'json',
            success: function (result) {
                let html = '';
                for (let i = 0; i < result.length; i++) {
                    html += `<option>${result[i]['city']}</option>`;
                }
                $('#cityList').html(html).trigger("chosen:updated");
                $('#cityListContainer').css('opacity', '1');
            },
        });
    });

    $('#registration').submit(function (event) {
        event.preventDefault();
        if ($('#registration').valid()) {
            $.ajax({
                type: 'post',
                url: 'registration',
                contentType: false,
                cache: false,
                processData: false,
                data: new FormData(this),
                success: function (result) {
                    let res = JSON.parse(result);
                   /* if (JSON.parse(result).errors) {
                        alert(JSON.parse(result).errors);
                    }*/
                    alert(res.msg);
                    $(location).attr('href', res.href)
                },
            });
        }
    });
});
