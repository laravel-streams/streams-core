import { params, suite, test } from '@testdeck/mocha';
import { TestCase } from '../TestCase';
import { Entry, Streams } from '@/Streams';


@suite
export class StreamsTest extends TestCase {

    @test
    async resolveStreamsInstanceTest() {
        const streams = this.app.get<Streams>('streams');
        streams.should.be.instanceof(Streams);
    }

    @test
    async makeStreamTest() {
        this.fs.createStream('clients', this.getStreamData('clients'));
        const streams = await this.getStreams();
        const stream  = await streams.make('clients');
        stream.id.should.eq('clients');
        const entry = await stream.repository.create({
            id   : 1,
            name : 'robin',
            email: 'robin@robin.com',
        });
        entry.should.be.instanceof(Entry);
        const entries = await stream.repository.all();

        return { entry, entries };
    }


    @params({ arg1: 'foo', arg2: 'bar' })
    @params.pending({ arg1: 'bar', arg2: 'foo' }, 'SUT does not yet support this')
    "test foobar against parameters"({ arg1, arg2 }) {
    }


}
