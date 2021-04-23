
// Date Picker

$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
});

// XHR pour gérer les relations

$('button.xhr').each(function(index) {
    this.addEventListener('click', function(event) {
        event.preventDefault();
        let parent = this.previousElementSibling.previousElementSibling;
        if(!parent)
        {
            $(this.parentNode).prepend('<ul class="list-group"></ul>');
            parent = this.previousElementSibling.previousElementSibling;
        }
        let ids = this.previousElementSibling.value.split(" - ");
        if(ids.length == 2)
        {
            $.ajax({
                method: "POST",
                url: this.dataset.xhr,
                data:{idOne: ids[0], idMany: ids[1]}
            }).done(function(json) {
                if(json.statut === "ok")
                {
                    $(parent).append('<li class="list-group-item">'+ json.text +'</li>');                                   
                }
                else
                {
                    $('.modal-body').html(json.error);
                    $('#Modal').modal('show'); 
                }
            });
        }
    });
});