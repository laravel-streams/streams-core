import { ServiceProvider } from '@/Support';
import { Streams } from '@/Streams/Streams';
import { HttpServiceProvider } from '@/Http/HttpServiceProvider';

export class StreamsServiceProvider extends ServiceProvider {
    providers: [
        HttpServiceProvider
    ]
    register() {
        this.app.singleton('streams', Streams);
    }
}
