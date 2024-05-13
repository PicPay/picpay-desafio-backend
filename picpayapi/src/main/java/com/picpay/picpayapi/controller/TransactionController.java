package com.picpay.picpayapi.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;

import com.picpay.picpayapi.dominio.transation.Transaction;
import com.picpay.picpayapi.dtos.TransactionDto;
import com.picpay.picpayapi.services.TransactionService;

@RestController()
@RequestMapping("/transactions")
public class TransactionController {

    @Autowired
    private TransactionService transactionService;

    @PostMapping()
    public ResponseEntity <Transaction> creatTransaction(@RequestBody TransactionDto transactionDto)throws Exception{

           Transaction new_Transaction = this.transactionService.creatTransaction(transactionDto);

           return new ResponseEntity<>(new_Transaction,HttpStatus.OK);
         
    }
}
