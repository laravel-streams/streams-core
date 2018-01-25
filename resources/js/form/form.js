$(function () {

    let $form = $("form.form");

    if ($form.find(document.location.hash).length > 0) {
        $form.find('a[href="'+document.location.hash+'"]').tab("show");
    }

    window.addEventListener("popstate", function(e) {
        if ($form.find(document.location.hash).length > 0) {
            $form.find('a[href="'+document.location.hash+'"]').tab("show");
        }
    });

    $form.find(".nav-sections > li > a").on("shown.bs.tab", function(e) {
        if (history.pushState) {
            history.pushState(null, "Show Tab", e.target.hash);
        } else {
            window.hash(e.target.hash);
        }
    });

    // Focus on the first input.
    $form.find("input:visible").first().focus();

    // Highlight tabs containing errors.
    $form.find(".has-danger").each(function () {

        let $field = $(this);
        let $pane = $field.closest(".tab-pane");

        if (!$pane.length) {
            return;
        }

        $form
            .find('[data-toggle="tab"][href="#' + $pane.attr('id') + '"]')
            .addClass("text-danger");
    });
});
