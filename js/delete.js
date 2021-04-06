require(['core/templates'], function(templates) {
    var context = { name: 'delete', intelligence: 2 };
    templates.render('local_message/delete', context)

        .then(function(html, js) {
            // var element = document.getElementById('');
            // alert(html);

        }).fail(function(ex) {
        alert(ex);
    });
});