<script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>

<button id="link-button">Open Link</button>

<script>
    var linkHandler = Plaid.create({
        env: 'sandbox',
        clientName: 'Plaid Sandbox',
        // Replace '<PUBLIC_KEY>' with your own `public_key`
        key: '<PUBLIC_KEY>',
        product: ['auth'],
        onSuccess: function(public_token, metadata) {
            // Send the public_token to your app server here.
            // The metadata object contains info about the
            // institution the user selected and the
            // account_id, if selectAccount is enabled.
        },
        onExit: function(err, metadata) {
            // The user exited the Link flow.
            if (err != null) {
                // The user encountered a Plaid API error
                // prior to exiting.
            }
            // metadata contains information about the
            // institution that the user selected and the
            // most recent API request IDs. Storing this
            // information can be helpful for support.
        }
    });
    // Trigger the standard institution select view
    document.getElementById('link-button').onclick = function() {
        linkHandler.open();
    };

    </script>