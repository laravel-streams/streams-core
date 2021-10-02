import { suite, test } from '@testdeck/mocha';
import {  TestCase } from './TestCase';
import { Repository } from '@/Config';


@suite
export class ConfigTest extends TestCase {

    makeRepository<DATA>(items:DATA):Repository<DATA>{
        return new Repository(items)
    }
    makeProxyRepository<DATA>(items:DATA): Repository<DATA> & DATA{
        return Repository.asProxy(items)
    }

    @test
    async getRepositoryItem() {
        let repo = this.makeRepository(this.getConfigData())
        repo.get('hash').should.eq('6157fc77301ecc4fb2df2962')
        repo.get('static').should.eq(false)
        repo.get('stuff').should.be.have.property('hash');
    }


}
