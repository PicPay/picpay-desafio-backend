package com.picpay.picpayapi.dtos;

import java.math.BigDecimal;

public record TransactionDto(
    BigDecimal valor , 
    Long senderId,
     Long receriverId
) {
    
}
