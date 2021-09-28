import { ServiceProvider } from '@/Support';
import { Streams } from '@/Streams/Streams';

export class StreamsServiceProvider extends ServiceProvider {
    register() {
        this.app.singleton('streams', Streams);
    }
}
