/* =====================================================================
   SATRACO ERP — Module Engins & Matériels : utilitaires JS partagés
   Requiert jQuery et SweetAlert2. Configuration injectée par la vue :
     window.EQ = { baseUrl, csrfName, csrfHash }
   ===================================================================== */
(function (w) {
    'use strict';

    var EQ = w.EQ || {};

    EQ.esc = function (v) {
        return String(v === null || v === undefined ? '' : v).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    };

    EQ.num = function (v, d) {
        var n = parseFloat(v);
        if (isNaN(n)) { n = 0; }
        d = d || 0;
        return n.toLocaleString('fr-FR', { minimumFractionDigits: d, maximumFractionDigits: d });
    };

    EQ.money = function (v) { return EQ.num(v, 0) + ' BIF'; };

    EQ.date = function (s) {
        if (!s) { return '-'; }
        var p = String(s).substr(0, 10).split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : s;
    };

    EQ.unit = function (type) { return type === 'heure' ? 'h' : (type === 'km' ? 'km' : ''); };

    EQ.url = function (path) {
        return String(EQ.baseUrl || '/').replace(/\/$/, '') + '/' + String(path).replace(/^\//, '');
    };

    function keepCsrf(res) {
        var j = res && res.responseJSON ? res.responseJSON : res;
        if (j && j.csrf) { EQ.csrfHash = j.csrf; }
    }

    EQ.post = function (path, data) {
        data = data || {};
        if (EQ.csrfName) { data[EQ.csrfName] = EQ.csrfHash; }
        return w.jQuery.ajax({ url: EQ.url(path), type: 'POST', data: data, dataType: 'json' })
            .done(keepCsrf).fail(keepCsrf);
    };

    EQ.get = function (path, data) {
        return w.jQuery.ajax({ url: EQ.url(path), type: 'GET', data: data || {}, dataType: 'json' });
    };

    EQ.fail = function (xhr) {
        var m = (xhr && xhr.responseJSON && xhr.responseJSON.message) || 'Une erreur est survenue. Réessayez.';
        w.Swal.fire({ icon: 'error', title: 'Action impossible', text: m });
    };

    EQ.toast = function (icon, title) {
        w.Swal.fire({ toast: true, position: 'top-end', timer: 2200, showConfirmButton: false, icon: icon, title: title });
    };

    EQ.confirm = function (opts) {
        return w.Swal.fire(Object.assign({
            icon: 'warning', showCancelButton: true, reverseButtons: true,
            confirmButtonText: 'Confirmer', cancelButtonText: 'Annuler', confirmButtonColor: '#dc3545'
        }, opts || {}));
    };

    EQ.fileIcon = function (name) {
        var n = String(name || '').toLowerCase();
        if (/\.pdf$/.test(n)) { return 'fas fa-file-pdf text-danger'; }
        if (/\.(doc|docx)$/.test(n)) { return 'fas fa-file-word text-primary'; }
        if (/\.(xls|xlsx)$/.test(n)) { return 'fas fa-file-excel text-success'; }
        if (/\.(jpg|jpeg|png)$/.test(n)) { return 'fas fa-file-image text-info'; }
        return 'fas fa-file text-secondary';
    };

    EQ.size = function (bytes) {
        if (!bytes) { return ''; }
        return bytes < 1048576 ? (bytes / 1024).toFixed(0) + ' Ko' : (bytes / 1048576).toFixed(1) + ' Mo';
    };

    /** Aperçu des fichiers choisis dans un <input type="file" multiple> */
    EQ.previewFiles = function (input, container) {
        container.innerHTML = '';
        Array.prototype.forEach.call(input.files || [], function (file) {
            if (/^image\//.test(file.type)) {
                var card = document.createElement('div');
                card.className = 'eq-thumb';
                var img = document.createElement('img');
                var label = document.createElement('span');
                label.textContent = file.name;
                label.title = file.name;
                card.appendChild(img);
                card.appendChild(label);
                container.appendChild(card);
                var reader = new FileReader();
                reader.onload = function (e) { img.src = e.target.result; };
                reader.readAsDataURL(file);
            } else {
                var doc = document.createElement('div');
                doc.className = 'eq-doc';
                var icon = document.createElement('i');
                icon.className = EQ.fileIcon(file.name) + ' fa-lg';
                var name = document.createElement('span');
                name.className = 'eq-doc-name';
                name.textContent = file.name;
                var size = document.createElement('small');
                size.className = 'text-muted';
                size.textContent = EQ.size(file.size);
                doc.appendChild(icon);
                doc.appendChild(name);
                doc.appendChild(size);
                container.appendChild(doc);
            }
        });
    };

    /** Imprime le contenu d'un élément dans une fenêtre dédiée (mêmes feuilles de style) */
    EQ.printElement = function (id, title) {
        var el = document.getElementById(id);
        if (!el) { return; }
        var links = Array.prototype.map.call(document.querySelectorAll('link[rel="stylesheet"]'), function (l) {
            return '<link rel="stylesheet" href="' + l.href + '">';
        }).join('');
        var win = w.open('', '_blank');
        if (!win) {
            w.Swal.fire('Impression bloquée', 'Autorisez les fenêtres pop-up pour imprimer.', 'info');
            return;
        }
        win.document.write('<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>' + EQ.esc(title) +
            '</title>' + links + '</head><body class="eq-print"><div class="eq-page">' + el.innerHTML + '</div></body></html>');
        win.document.close();
        setTimeout(function () { win.focus(); win.print(); }, 700);
    };

    w.EQ = EQ;
})(window);

/* Menus ⋮ dans les tableaux défilants : affichés au-dessus de la page */
(function (w) {
    'use strict';
    if (!w.eqOnReady) { return; }

    w.eqOnReady(function ($) {
        var sel = '.eq-page .table-responsive .dropdown';

        $(document).on('shown.bs.dropdown', sel, function () {
            var $dd = $(this);
            var $menu = $dd.find('.dropdown-menu');
            if (!$menu.length) { return; }
            var r = $menu[0].getBoundingClientRect();
            $dd.data('eq-menu', $menu);
            $menu.appendTo('body').addClass('show').css({
                position: 'fixed', top: r.top, left: r.left,
                transform: 'none', zIndex: 1060
            });
        });

        $(document).on('hide.bs.dropdown', sel, function () {
            var $menu = $(this).data('eq-menu');
            if ($menu) {
                $menu.removeClass('show')
                    .css({ position: '', top: '', left: '', transform: '', zIndex: '' })
                    .appendTo(this);
                $(this).removeData('eq-menu');
            }
        });

        /* Ferme le menu si on fait défiler la page */
        $(w).on('scroll', function () {
            $('.eq-page .dropdown.show [data-toggle="dropdown"]').dropdown('hide');
        });
    });
})(window);
