package com.picpay.picpayapi.services;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;

import com.picpay.picpayapi.dominio.user.User;
import com.picpay.picpayapi.dtos.NotficatioDto;

@Service
public class NotificationService {

    @Autowired
    private RestTemplate restTemplate;

    public void seendNotication( User user, String messeger)throws Exception{

        String email = user.getEmail();
        NotficatioDto notficatioDto = new NotficatioDto(email, messeger);

    /* 
        ResponseEntity<String> retorno= restTemplate.postForEntity("https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6",notficatioDto, String.class);
         if ( !( retorno.getStatusCode() == HttpStatus.OK)) {
            System.out.println("erro ao enviar notificação");
            throw new Exception("Sistema for do ar");
         }*/

         System.out.println("notificaçao enviada");
    }
}
