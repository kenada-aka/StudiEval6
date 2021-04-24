
// Menu navbar (version 2)

let active = 0;

$("#navbar a").each(function(index) {
    console.log(this.href);
    if(window.location.pathname == this.href.replace(window.location.origin, ""))
    {
        this.classList.add("active");
        active++;
    }
    else this.classList.remove("active");
});

if(active == 0 && window.location.pathname == "/")
{
    $("#navbar a")[0].classList.add("active");
}

$("#navbar a").click(function(event) {
    $("#navbar a").each(function(index) {
        this.classList.remove("active");
    });
    this.classList.toggle("active");
});

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