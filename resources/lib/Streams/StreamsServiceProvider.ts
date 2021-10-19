import { Http } from '../Streams/Http';
import { ServiceProvider } from '../Support';
import { Streams } from '../Streams/Streams';
import { HttpServiceProvider } from '../Http/HttpServiceProvider';
import { app } from '../Foundation';

export class StreamsServiceProvider extends ServiceProvider {

    /**
     * Register the service.
     */
    register() {

        this.app.singleton('streams', Streams).addBindingGetter('streams');

        this.app.singleton('streams.http', Http);
    }
}
