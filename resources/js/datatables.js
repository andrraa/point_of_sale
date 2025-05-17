import DataTables from "datatables.net";

// DATATABLE TAILWIND
(function (factory) {
    if (typeof define === "function" && define.amd) {
        define(["jquery", "datatables.net"], function ($) {
            return factory($, window, document);
        });
    } else {
        factory($, window, document);
    }
})(function ($, window, document) {
    "use strict";
    var DataTable = $.fn.dataTable;

    $.extend(true, DataTable.defaults, {
        renderer: "tailwindcss",
    });

    // Default class modification
    $.extend(true, DataTable.ext.classes, {
        container: "dt-container dt-tailwindcss",
        search: {
            input: "border ml-2 px-4 py-2 text-sm rounded-lg border-gray-300 outline-none text-black/90",
        },
        length: {
            select: "border p-2 rounded-lg border-gray-300 outline-none cursor-pointer",
        },
        processing: {
            container: "dt-processing",
        },
        paging: {
            active: "font-medium bg-gray-50 text-blue-900",
            notActive: "bg-white",
            button: "relative inline-flex justify-center items-center space-x-2 border px-3 py-1 -mr-px leading-6 hover:z-10 focus:z-10 active:z-10 border-gray-200 active:border-gray-200 active:shadow-none",
            first: "rounded-l-lg",
            last: "rounded-r-lg",
            enabled: "text-gray-800 hover:text-blue-900",
            notEnabled: "text-gray-300",
        },
        table: "dataTable min-w-full text-sm align-middle whitespace-nowrap",
        thead: {
            row: "border-b border-gray-300",
            cell: "p-3 tracking-wide text-gray-900 bg-gray-100/70 font-semibold text-left",
        },
        tbody: {
            row: "even:bg-gray-100/50 divide-y divide-gray-100",
            cell: "p-3 text-sm text-gray-700 whitespace-nowrap",
        },
        tfoot: {
            row: "even:bg-gray-50",
            cell: "p-3 text-left",
        },
    });

    DataTable.ext.renderer.pagingButton.tailwindcss = function (
        settings,
        buttonType,
        content,
        active,
        disabled
    ) {
        var classes = settings.oClasses.paging;
        var btnClasses = [classes.button];

        btnClasses.push(active ? classes.active : classes.notActive);
        btnClasses.push(disabled ? classes.notEnabled : classes.enabled);

        var a = $("<a>", {
            href: disabled ? null : "#",
            class: btnClasses.join(" "),
        }).html(content);

        return {
            display: a,
            clicker: a,
        };
    };

    DataTable.ext.renderer.pagingContainer.tailwindcss = function (
        settings,
        buttonEls
    ) {
        var classes = settings.oClasses.paging;

        buttonEls[0].addClass(classes.first);
        buttonEls[buttonEls.length - 1].addClass(classes.last);

        return $("<ul/>").addClass("pagination").append(buttonEls);
    };

    DataTable.ext.renderer.layout.tailwindcss = function (
        settings,
        container,
        items
    ) {
        var row = $("<div/>", {
            class: items.full
                ? "grid grid-cols-1 gap-4 mb-4"
                : "grid grid-cols-2 gap-4 mb-4",
        }).appendTo(container);

        DataTable.ext.renderer.layout._forLayoutRow(items, function (key, val) {
            var klass;

            if (val.table) {
                klass = "col-span-2";
            } else if (key === "start") {
                klass = "justify-self-start";
            } else if (key === "end") {
                klass = "col-start-2 justify-self-end";
            } else {
                klass = "col-span-2 justify-self-center";
            }

            $("<div/>", {
                id: val.id || null,
                class: klass + " " + (val.className || ""),
            })
                .append(val.contents)
                .appendTo(row);
        });
    };

    return DataTable;
});

// ACTION BUTTON
export function actions(data, selector) {
    let actions = ``;

    if (data.hasOwnProperty('edit')) {

    }

    if (data.hasOwnProperty('detail')) {

    }

    if (data.hasOwnProperty('delete')) {
        
    }

    return actions += ``;
}

// EXPORT THE WINDOW
window.DataTables = DataTables;
window.DataTablesAction = actions;