import { suite, test } from '@testdeck/mocha';
import { TestCase } from './TestCase';
import { Http } from '@/Streams/Http';


@suite
export class HttpTest extends TestCase {

    @test
    async resolveHttpInstanceTest() {
        const app  = await this.createApp();
        const http = app.get<Http>('streams.http');
        http.should.be.instanceof(Http);
    }

    @test
    async getStreamTest() {
        const http = await this.getHttp();
        http.should.be.instanceof(Http);
        const stream = await http.getStream('users');
        stream.should.have.property('data');
    }

    @test
    async getInvalidStreamTest() {
        const http = await this.getHttp();
        try {
            const stream = await http.getStream('users2');
        } catch (e) {
            e.should.have.property('isAxiosError');
        }
    }

    @test
    async postStreamTest() {
        this.fs.delete('streams/clients.json');
        const http   = await this.getHttp();
        const stream = await http.postStream(this.getStreamData('clients'));
        this.fs.exists('streams/clients.json').should.eq(true)
        stream.should.have.property('data');
        stream.data.should.have.property('id')
        stream.should.have.property('links')
        stream.should.have.property('meta')
        stream.should.have.property('errors')

        const response = await http.deleteStream(stream.data.id);
        response.should.eq('');
        this.fs.exists('streams/clients.json').should.eq(false)
    }

    @test
    async postEntryTest(){
        this.fs.create('streams/clients.json', this.getStreamData('clients'))
        const http   = await this.getHttp();
        const entry = await http.postEntry('clients', {
            name: 'Robin',
            email: 'robin@robin.com',
        })
        return;
    }



}
