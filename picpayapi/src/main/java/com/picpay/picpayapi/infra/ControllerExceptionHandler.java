package com.picpay.picpayapi.infra;

import org.springframework.dao.DataIntegrityViolationException;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.RestControllerAdvice;

import com.picpay.picpayapi.dtos.Excptiondto;

import jakarta.persistence.EntityNotFoundException;

@RestControllerAdvice
public class ControllerExceptionHandler {

    @ExceptionHandler(DataIntegrityViolationException.class)
    public ResponseEntity  threatDuplicatEntry(DataIntegrityViolationException exception){
        Excptiondto excptiondto = new Excptiondto("Usuario já cadastrado", "400");
        return ResponseEntity.badRequest().body(excptiondto);
    }

    @ExceptionHandler(EntityNotFoundException.class)
    public ResponseEntity the404(EntityNotFoundException exception){
        return ResponseEntity.notFound().build();
    }
    

    @ExceptionHandler(Exception.class)
    public ResponseEntity the404(Exception exception){
        Excptiondto excptiondto = new Excptiondto(exception.getMessage(), "500");
        return ResponseEntity.internalServerError().body(excptiondto);
    }
    
}
