package com.picpay.picpayapi.services;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
//import org.springframework.http.HttpStatusCode;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;

import com.picpay.picpayapi.dominio.transation.Transaction;
import com.picpay.picpayapi.dominio.user.User;
import com.picpay.picpayapi.dominio.user.UserType;
import com.picpay.picpayapi.dtos.TransactionDto;
//import com.picpay.picpayapi.dominio.transation.Transaction;
import com.picpay.picpayapi.repositories.TransactionRepository;

@Service
public class TransactionService {
    @Autowired
    private UserServices userServices;

    @Autowired 
    private TransactionRepository transactionRepository;

    @Autowired
    private RestTemplate restTemplate;
    
   @Autowired
    private NotificationService notificationService;
    public Transaction creatTransaction(TransactionDto transactionDto) throws Exception{

        User sender = this.userServices.findUserById(transactionDto.senderId());
        User receiver = this.userServices.findUserById(transactionDto.receriverId());


        userServices.validarTrasferencia(sender, transactionDto.valor());
        boolean autorizer =this.authorizerTransactiopn(sender, transactionDto.valor());

        if( autorizer ){
             throw new Exception("Trasation negada");
        }

        Transaction newtransaction = new Transaction(); 
        newtransaction.setAmount(transactionDto.valor());
        newtransaction.setSender(sender);
        newtransaction.setReceiver(receiver);
        newtransaction.setDateTime(LocalDateTime.now());  

        sender.setBalance(sender.getBalance().subtract(transactionDto.valor()));
        receiver.setBalance(receiver.getBalance().add(transactionDto.valor()));

        this.transactionRepository.save(newtransaction);
        this.userServices.saveUser(sender);
        this.userServices.saveUser(receiver);

        this.notificationService.seendNotication(receiver, "Transação recebida com 100%");
        this.notificationService.seendNotication(sender, "Transação enviada com 100%");

        return newtransaction;
    }

    public boolean authorizerTransactiopn( User sender, BigDecimal valor){

       // ResponseEntity <Map> autorizationResponde = restTemplate.getForEntity("https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc", Map.class);
   
    //    if(autorizationResponde.getStatusCode() == HttpStatus.OK){
           
            //  String messeger = (String) autorizationResponde.getBody().get("messeger");
           //   return "Autorizado".equalsIgnoreCase(messeger);

      //  }else{

        if( !sender.getType().equals(" USER_COMMON")){
             return false;
        }
            return true;
     //   }
    }
    
}
