
export function init() {
    console.log('Init');

    // const eventSource = new EventSource("{{ mercure('overkill_send')|escape('js') }}");
    // eventSource.onmessage = event => {
    //     // Will be called every time an update is published by the server
    //     console.log(JSON.parse(event.data));
    // }
}
