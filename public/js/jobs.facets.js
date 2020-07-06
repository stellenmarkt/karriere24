    /**
 * YAWIK
 *
 * License: MIT
 * (c) 2013 - 2017 CROSS Solution <http://cross-solution.de>
 */

/**
 *
 * Author: Mathias Gelhausen <gelhausen@cross-solution.de>
 */
;(function ($) {

    function renameFacetsFilter($form)
    {
        var facets={ r: [], loc: [], c: [], p: [], i: [], t: [] };

        $form.find('.facet-param').each(function(){
            var $checkbox = $(this);
            var name = $checkbox.attr('name').replace(/"/g, '&quot;');
            var value=name.replace(/^[^\[]+\[(.*)\]$/, '$1');
            if (name.match(/^region/)) {
                facets.r.push(value);
            } else if (name.match(/^city/)) {
                facets.loc.push(value);
            } else if (name.match(/^organiz/)) {
                facets.c.push(value);
            } else if (name.match(/^profession/)) {
                facets.p.push(value);
            } else if (name.match(/^industry/)) {
                facets.i.push(value);
            } else if (name.match(/^employ/)) {
                facets.t.push(value);
            }
        }).remove();

        for (var key in facets) {
            if (facets[key].length) {
                $form.append('<input class="facet-param" type="hidden" name="' + key + '" value="' + facets[key].join('_') + '">');
            }
        }

    }

    $(function() {
        var $form = $('#jobs-list-filter');
        $(document).on('click', '.facet-checkbox', function () {
            var $checkbox = $(this),
                $form = $('#jobs-list-filter'),
                name = $checkbox.attr('name').replace(/"/g, '&quot;');
            $form.find('input[name="' + name + '"]').remove();
            if ($checkbox.prop('checked')) {
                $form.append('<input type="hidden" class="facet-param" name="' + name + '">');
            }
            $form.trigger('submit');//, {forceAjax: true});
        }).on('click', '.facet-active', function () {
            $('#jobs-list-filter').find('input[name="' + $(this).data('name').replace(/"/g, '&quot;') + '"]').remove()
                .end().trigger('submit'); //, {forceAjax: true});
        }).on('click', '.facet-reset', function () {

            $form.find('.facet-param').remove()
                .end().trigger('submit'); //, {forceAjax: true});
        });

        $form
            .on('reset.facets', function() { $form.find('.facet-param').remove();})
            .on('submit.facets', function(e, flags) {
                if (!flags || !flags.forceAjax) {
                    renameFacetsFilter($form);
                }
            })
        ;

    });

})(jQuery);

