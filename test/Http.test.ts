import {suite,test} from '@testdeck/mocha'
import { TestCase } from './TestCase';
import { Http } from '@/Streams/Http';




@suite
export class HttpTest extends TestCase {

    @test
    async firstTest(){
        const app = await this.createApp()
        const http = app.get<Http>('streams.http');
        http.should.be.instanceof(Http);
    }

    @test
    async secondTest(){
        const http = await this.getHttp();
        const stream = await http.getStream('users')
        stream.should.have.property('data')
    }
}
