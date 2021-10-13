declare global {
    export interface StreamsGlobal {
        core: typeof import('./index');
    }

    export interface Window {
        streams: StreamsGlobal;
    }
}
