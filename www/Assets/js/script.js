window.App = {
    tableRow: function (id, name, age) {
        return '<tr class="d-flex">' +
            '<th class="col-1 text-center" scope="row">' + id + '</th>' +
            '<td class="col-4 text-center">' + name + '</td>' +
            '<td class="col-1 text-center">' + age + '</td>' +
            '<td class="col-3 text-center">' +
            '<button data-id="' + id + '" data-name="' + name + '" data-age="' + age + '" data-toggle="modal" data-type="update" data-target="#modal"' +
            ' class="btn btn-outline-info"><i class="fas fa-user-edit"></i> </button>' +
            '</td>' +
            '<td class="col-3 text-center">' +
            '<button data-id="' + id + '" ' +
            'onclick="App.deleteUser(this)" class="btn btn-outline-danger">' +
            '<i class="fas fa-user-times"></i> </button>' +
            '</td>' +
            '</tr>';
    },
    readAllHtml: function (response) {
        response = JSON.parse(response);
        if (response.length > 0) {
            var html = '';
            for (var user in response) {
                var id = response[user].id;
                var name = response[user].name;
                var age = response[user].age;
                html += App.tableRow(id, name, age);
            }

        } else {
            html = '<div class="loader text-center">' +
                '<h3 class="text-black-50">No Users Founded</h3>' +
                '</div>';
        }
        $('#table_body').html(html);
    },
    getAllUsers: function () {
        $.ajax({
            url: "http://localhost/API/index.php",
            type: "POST",
            data: {target: "all", param: {}},
            beforeSend: function () {
                var html = '<div class="loader text-center">' +
                    '<div class="spinner-border" role="status">\n' +
                    '  <span class="sr-only">Loading...</span>\n' +
                    '</div>' +
                    '</div>';
                $('#table_body').html(html);
            },
            success: App.readAllHtml
        });
    },
    ajaxRequest: function (data) {
        $.ajax({
            url: "http://localhost/API/index.php",
            type: "POST",
            data: data,
            success: function (response) {
                response = JSON.parse(response);
                if (response.state.toLowerCase() === "success") {
                    App.getAllUsers();
                }
            },
        });
    },
    createUser: function (name, age) {
        var data = {target: "create", param: {name: name, age: age}};
        App.ajaxRequest(data);
    },
    updateUser: function (id, name, age) {
        var data = {target: "update", param: {id: id, name: name, age: age}};
        App.ajaxRequest(data);
    },
    deleteUser: function (el) {
        var id = el.dataset.id;
        var data = {target: "delete", param: {id: id}};
        App.ajaxRequest(data);
    },
    prepareInput: function () {
        var nameEl = $('#name');
        var ageEl = $('#age');

        var name = nameEl.val();
        var age = ageEl.val();
        if (!name) {
            $('#name').addClass('is-invalid');
            return;
        }

        if (!age) {
            $('#age').addClass('is-invalid');
            return;
        }

        nameEl.removeClass('is-invalid');
        nameEl.val('');
        ageEl.removeClass('is-invalid');
        ageEl.val('');
        return {name: name, age: age};
    },
    updateValues: function (button) {
        var name = button.data('name');
        var age = button.data('age');
        var id = button.data('id');

        $('#name').val(name);
        $('#age').val(age);
        $('#id').val(id);
    },
    onSave: function (el) {
        var type = $('#modal').find('.modal-title').text();
        var data = App.prepareInput();

        if (type.toLowerCase() === 'create') {
            App.createUser(data.name, data.age);
        } else if (type.toLowerCase() === 'update'){
            var id = $('#id').val();
            App.updateUser(id, data.name, data.age);
        }

        $('#modal').modal('hide');
    }
};


$(document).ready(function () {
    App.getAllUsers();
    $('#modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var type = button.data('type');
        var modal = $(this);
        var nameEl = $('#name');
        var ageEl = $('#age');
        modal.find('.modal-title').text(type.toUpperCase());
        if(type.toLowerCase() === 'update')
            App.updateValues(button);
        modal.on('hide.bs.modal', function () {
            nameEl.removeClass('is-invalid');
            nameEl.val('');
            ageEl.removeClass('is-invalid');
            ageEl.val('');
        });
    });
});