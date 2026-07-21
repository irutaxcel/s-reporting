<!-- jQuery -->
<script src="<?= base_url('assets/v1/') ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/v1/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/v1/') ?>dist/js/adminlte.min.js"></script>

<script>
let deferredPwaPrompt = null;

const installPwaButton = document.getElementById(
    'installPwaButton'
);

window.addEventListener(
    'beforeinstallprompt',
    function(event) {

        event.preventDefault();

        deferredPwaPrompt = event;

        if (installPwaButton) {
            installPwaButton.style.display = 'inline-block';
        }

    }
);

if (installPwaButton) {

    installPwaButton.addEventListener(
        'click',
        async function() {

            if (!deferredPwaPrompt) {
                return;
            }

            deferredPwaPrompt.prompt();

            const choiceResult =
                await deferredPwaPrompt.userChoice;

            console.log(
                'Choix installation :',
                choiceResult.outcome
            );

            deferredPwaPrompt = null;

            installPwaButton.style.display = 'none';

        }
    );

}

window.addEventListener(
    'appinstalled',
    function() {

        console.log(
            'Application SATRACO installée avec succès.'
        );

        deferredPwaPrompt = null;

        if (installPwaButton) {
            installPwaButton.style.display = 'none';
        }

    }
);
</script>
</body>

</html>