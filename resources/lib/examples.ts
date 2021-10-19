import { app } from '../Foundation';
import { Streams } from '../Streams';

export namespace examples {
    export async function test() {

        const streams = app.get<Streams>('streams');
        const all     = await streams.all();
        const stream  = await streams.make('users');
        const users   = await stream.entries()
                                    .where('id', '>', 0)
                                    .orderBy('id')
                                    .get();


    }

}
