import { suite, test } from '@testdeck/mocha';
import { TestCase } from './TestCase';
import { Http } from '@/Streams/Http';
import { Entry, Streams } from '@/Streams';


@suite
export class StreamsTest extends TestCase {

    @test
    async resolveStreamsInstanceTest() {
        const app  = await this.createApp();
        const streams = app.get<Streams>('streams');
        streams.should.be.instanceof(Streams);
    }

    @test
    async makeStreamTest() {
        this.fs.create('streams/clients.json', this.getStreamData('clients'))
        const streams = await this.getStreams();
        const stream = await streams.make('clients')
        stream.id.should.eq('clients')
        const entry = await stream.repository.create({
            id: 1,
            name: 'robin',
            email: 'robin@robin.com'
        })
        entry.should.be.instanceof(Entry);
        const entries = await stream.repository.all()

        return {entry,entries};
    }


}
