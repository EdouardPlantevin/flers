/** Form input */

$(document).ready(function () {

    $(".form-check").each(function () {

        let inputContainer = $(this);
        let labelText = inputContainer.find(".form-check-label").text();
        inputContainer.find(".form-check-label").text("");

        let labelDiv = inputContainer.find(".form-check-label");
        let input = inputContainer.find("input")

        let span = $([
            '<span class="form-check-sign">' + labelText + '</span>'
        ].join(''));

        labelDiv.append(input);
        labelDiv.append(span);

    });

});


/** Photo uploader */
$(document).ready(function () {
    var readURL = function (input, imageWrapper) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imageWrapper.find('.preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            imageWrapper.find(".change-photo-btn").removeClass('hide');
        }
    }
    $(".select-image-input").on('change', function () {
        let imageWrapper = $(this).closest('.image-wrapper');
        readURL(this, imageWrapper);
    });
    $(".preview-image, .change-photo-btn").on('click', function () {
        $(this).closest('.image-wrapper').find('.select-image-input').click();
    });
});

/** Datepicker */

$('.datepicker').datetimepicker({
    format: 'DD/MM/YYYY',
});


/** Data Table */

$(document).ready(function () {
    $('.data-table').DataTable({
        "order": [],
        "language": {
            "lengthMenu": "Afficher _MENU_ lignes par page",
            "zeroRecords": "Aucun resultat",
            "info": "Page _PAGE_ of _PAGES_",
            "search": "Recherche",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "paginate": {
                "first": "Début",
                "last": "Fin",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": Trier par ordre croissant",
                "sortDescending": ": Trier par order décroissant"
            }
        },
        columnDefs: [
            { orderable: false, targets: [-1, -1 ]}
        ],
        "pageLength": 25
    });
});




$(document).ready(function() {
    $('.select-search').select2();
    $("input[type='text']").attr("maxlength", "255");
});

