<script type="text/javascript">

    const APPLICATION_URL = "{{ url() }}";
    const APPLICATION_REFERENCE = "{{ env('APPLICATION_REFERENCE') }}";
    const APPLICATION_DOMAIN = "{{ env('APPLICATION_DOMAIN') }}";

    const CSRF_TOKEN = "{{ csrf_token() }}";
    const APP_DEBUG = "{{ config('app.debug') }}";
    const APP_URL = "{{ config('app.url') }}";
    const REQUEST_ROOT = "{{ request_root() }}";
    const REQUEST_ROOT_PATH = "{{ parse_url(request().root()).path }}";
    const TIMEZONE = "{{ config('app.timezone') }}";
    const LOCALE = "{{ config('app.locale') }}";
    
</script>
