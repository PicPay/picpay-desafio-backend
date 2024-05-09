package com.picpay.picpayapi.dominio.transation;

import java.math.BigDecimal;
import java.time.LocalDate;
import java.time.LocalDateTime;

import org.springframework.cglib.core.Local;

import com.picpay.picpayapi.dominio.user.User;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

@Entity(name = "transactions")
@Table(name = "transactions")


@Data
@AllArgsConstructor
@NoArgsConstructor
@EqualsAndHashCode(of="id")

public class Transaction {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    
    private BigDecimal amount; // valor a  ser transferido

    @ManyToOne
    @JoinColumn(name = "sender_id")
    private User sender;

    @ManyToOne
    @JoinColumn(name = "recever_id")
    private User receiver;


    private LocalDateTime dateTime;// horario da trascao
}
