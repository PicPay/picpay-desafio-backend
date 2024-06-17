import React, { useEffect } from 'react';
import { Api } from '../../../contexts/api';

import Navbar from 'react-bootstrap/Navbar';
import Form from 'react-bootstrap/Form';
import InputGroup from 'react-bootstrap/InputGroup';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Transacao from './transacao';

const NavSaldoPessoaFIsica: React.FC = () => {

  const [saldo, setSaldo] = React.useState('');

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await Api.get('/usuarios/4/');
        // Acessar o saldo dentro de saldoUser
        const saldo = response.data.saldoUser[0]?.saldo || '0.00';
        setSaldo(saldo);
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    };

    fetchUserData();
  }, []);


    return (
        <Navbar className="bg-body-tertiary justify-content-between">
          <Form>
            <InputGroup>
              <InputGroup.Text id="basic-addon1">R$</InputGroup.Text>
              <Form.Control
                // disabled
                placeholder="Saldo"
                aria-describedby="basic-addon1"
                value={saldo}
              />
            </InputGroup>
          </Form>
          <Form>
            <Row>
            <Col xs="auto">
                <p>0000 / 00.000000.0</p>
              </Col>
              <Col xs="auto">
                <Transacao/>
              </Col>
            </Row>
          </Form>
        </Navbar>
      );
};

export default NavSaldoPessoaFIsica;
