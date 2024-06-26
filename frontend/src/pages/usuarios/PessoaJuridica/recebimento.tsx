import React from 'react';

import {QRCodeSVG} from 'qrcode.react';
import { toPng } from 'html-to-image';
import * as clipboard from "clipboard-polyfill";

import { Button, Modal } from 'react-bootstrap';


const Recebimento: React.FC = () => {

    const [modalShow, setModalShow] = React.useState(false);
    const qrCodeRef = React.useRef<HTMLDivElement>(null);

    const handleClose = () => setModalShow(false);
    const handleShow = () => setModalShow(true);

    const handleCopyQRCode = async () => {
        if (qrCodeRef.current) {
          try {
            const dataUrl = await toPng(qrCodeRef.current);
            await clipboard.writeText(dataUrl);
            alert('QR Code copiado com sucesso!');
          } catch (error) {
            console.error('Erro ao copiar QR Code:', error);
            alert('Falha ao copiar QR Code.');
          }
        }
      };

    return (
        <>
        <div>
        <Button variant="primary" onClick={handleShow}>
           Cobrar Valor
        </Button>
        
        <Modal
                show={modalShow}
                onHide={handleClose}
                size="lg"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
            <Modal.Header closeButton>
                <Modal.Title>Receber</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div ref={qrCodeRef}>
                    <QRCodeSVG
                        value={"http://localhost:5173/PessoaJuridica"} />
                </div>
            </Modal.Body>

            <Modal.Body>
                <Button variant="primary" onClick={handleCopyQRCode}>
                    Copiar Qrcode
                </Button>

            </Modal.Body>
        </Modal>

        </div>
        </>
    );
};

export default Recebimento;
