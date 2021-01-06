import { ExampleClass }      from './ExampleClass';
import { UiServiceProvider } from './UiServiceProvider';

declare global {
    export interface StreamsGlobalUi {
        ExampleClass: typeof ExampleClass;
        UiServiceProvider: typeof UiServiceProvider;
    }

    export interface StreamsGlobal {
        ui: StreamsGlobalUi;
    }
}
