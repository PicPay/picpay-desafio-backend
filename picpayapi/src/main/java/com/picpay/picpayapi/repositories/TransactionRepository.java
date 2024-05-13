package com.picpay.picpayapi.repositories;

import org.springframework.data.jpa.repository.JpaRepository;

import com.picpay.picpayapi.dominio.transation.Transaction;

public interface TransactionRepository extends JpaRepository<Transaction,Long> {
    
}
