jQuery(function(a) {

    function b() {

        var a = {

            formatMatches: function(a) {

                return 1 === a ? wc_country_select_params.i18n_matches_1 : wc_country_select_params.i18n_matches_n.replace("%qty%", a)

            },

            formatNoMatches: function() {

                return wc_country_select_params.i18n_no_matches

            },

            formatAjaxError: function() {

                return wc_country_select_params.i18n_ajax_error

            },

            formatInputTooShort: function(a, b) {

                var c = b - a.length;

                return 1 === c ? wc_country_select_params.i18n_input_too_short_1 : wc_country_select_params.i18n_input_too_short_n.replace("%qty%", c)

            },

            formatInputTooLong: function(a, b) {

                var c = a.length - b;

                return 1 === c ? wc_country_select_params.i18n_input_too_long_1 : wc_country_select_params.i18n_input_too_long_n.replace("%qty%", c)

            },

            formatSelectionTooBig: function(a) {

                return 1 === a ? wc_country_select_params.i18n_selection_too_long_1 : wc_country_select_params.i18n_selection_too_long_n.replace("%qty%", a)

            },

            formatLoadMore: function() {

                return wc_country_select_params.i18n_load_more

            },

            formatSearching: function() {

                return wc_country_select_params.i18n_searching

            }

        };

        return a

    }

    if ("undefined" == typeof wc_country_select_params) return !1;  

    if (a().select2) {

        var c = function() {

            a("select.country_select:visible, select.state_select:visible").each(function() {

                var c = a.extend({

                    placeholderOption: "first",

                    width: "100%"

                }, b());

                a(this).select2(c)

            })

        };

        c(), a(document.body).bind("country_to_state_changed", function() {

            c()

        })

    }

    var d = wc_country_select_params.countries.replace(/&quot;/g, '"'),

        e = a.parseJSON(d);

    a(document.body).on("change", "select.country_to_state, input.country_to_state", function() {

    a('#billing_state_field').css('visibility','visible');

        var b = a(this).val(),

            c = a(this).closest(".form-row").parent(),

            d = c.find("#billing_state, #shipping_state, #calc_shipping_state"),

            f = d.parent(),

            g = d.attr("name"),

            h = d.attr("id"),

            i = d.val(),

            j = d.attr("placeholder") || d.attr("data-placeholder") || "";

        if (e[b])

            if (a.isEmptyObject(e[b])) d.parent().hide().find(".select2-container").remove(), d.replaceWith('<input type="hidden" class="hidden" name="' + g + '" id="' + h + '" value="" placeholder="' + j + '" />'), a(document.body).trigger("country_to_state_changed", [b, c]);

            else {

                var k = "",

                    l = e[b];

                for (var m in l) l.hasOwnProperty(m) && (k = k + '<option value="' + m + '">' + l[m] + "</option>");

                d.parent().show(), d.is("input") && (d.replaceWith('<select name="' + g + '" id="' + h + '" class="state_select" data-placeholder="' + j + '"></select>'), d = c.find("#billing_state, #shipping_state, #calc_shipping_state")), d.html('<option value="">' + wc_country_select_params.i18n_select_state_text + "</option>" + k), d.val(i).change(), a(document.body).trigger("country_to_state_changed", [b, c])

            }

        else { d.is("select") ? (f.show().find(".select2-container").remove(), d.replaceWith('<input type="text" value="N/A" class="input-text" name="' + g + '" id="' + h + '" placeholder="' + j + '" />'), a(document.body).trigger("country_to_state_changed", [b, c])) : d.is('input[type="hidden"]') && (f.show().find(".select2-container").remove(), d.replaceWith('<input type="text" class="input-text" name="' + g + '" id="' + h + '" placeholder="' + j + '" />'), a(document.body).trigger("country_to_state_changed", [b, c])); 

         // a('#billing_state_field').css('visibility','hidden');

          a('#billing_postcode_field').hide();         

        }

        a(document.body).trigger("country_to_state_changing", [b, c])

    }), a(function() {

        a(":input.country_to_state").change()

    })

});