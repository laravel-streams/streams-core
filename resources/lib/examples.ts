import { app } from '@/Foundation';
import { StreamsServiceProvider } from '@/Streams';
import { HttpServiceProvider } from '@/Http/HttpServiceProvider';


app
.initialize({
    providers: [
        HttpServiceProvider,
        StreamsServiceProvider,
    ],
    config: {
        http: {

        },
        streams: {

        }
    }
})
.then(app => app.boot())
.then(app => app.start());
