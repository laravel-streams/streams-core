import { Http } from '@/Streams/Http';
import { ServiceProvider } from '@/Support';
import { Streams } from '@/Streams/Streams';
import { HttpServiceProvider } from '@/Http/HttpServiceProvider';

export class StreamsServiceProvider extends ServiceProvider {
    
    /**
     * Other providers to load.
     */
    providers: [
        HttpServiceProvider
    ];

    /**
     * Register the service.
     */
    register() {
        
        this.app.singleton('streams', Streams).addBindingGetter('streams');

        this.app.singleton('streams.http', Http);
    }
}
