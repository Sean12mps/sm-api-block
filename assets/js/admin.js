jQuery(document).ready(function ($) {
  // Add listener to the button.
  $(document).on('click', '.sm-api-block-notice .notice-dismiss', function (e) {
    // clear notice query string from url.
    const url = new URL( window.location.href );

    // remove notice query string.
    url.searchParams.delete( 'notice' );

    // update url.
    window.history.replaceState( null, null, url );
  });
});
