package com.challenge.picpay.core.services;

import com.challenge.picpay.core.repositories.UserRepository;
import com.challenge.picpay.domain.enums.exceptions.UserExceptionsMessages;
import com.challenge.picpay.domain.models.entities.User;
import com.challenge.picpay.web.common.exceptions.notfound.NotFoundException;
import com.challenge.picpay.web.common.validations.ValidatePageSize;
import jakarta.transaction.Transactional;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.util.UUID;

@AllArgsConstructor

@Service
public class UserServiceImpl implements UserService{

    private UserRepository repository;
    private ValidatePageSize validatePageSize;
    private static final int DECREASE_PAGE_SIZE = 1;
    private static final int ZERO_PAGE_SIZE = 0;

    @Override
    public Page<User> getAll(int page, int size) {
        if(page > ZERO_PAGE_SIZE) {
            page -= DECREASE_PAGE_SIZE;
        }
        validatePageSize.getAllPageSizeValidation(page, size);
        Pageable pageableRequest = PageRequest.of(page, size);
        return repository.findAll(pageableRequest);
    }

    @Override
    public User findById(UUID uuid) {
        return repository.findById(uuid).orElseThrow(() -> new NotFoundException(UserExceptionsMessages.NOT_FOUND.message));
    }

    @Transactional
    @Override
    public User save(User user) {
        return repository.save(user);
    }

    @Transactional
    @Override
    public User update(User user, UUID uuid) {
        return repository.findById(uuid).map(existingUser -> {
            user.setId(existingUser.getId());
            repository.save(user);
            return user;
        }).orElseThrow(() -> new NotFoundException(UserExceptionsMessages.NOT_FOUND.message));
    }

    @Transactional
    @Override
    public void delete(UUID uuid) {
        repository.findById(uuid)
            .map(existingUser -> {
               repository.delete(existingUser);
               return existingUser;
            }).orElseThrow(() -> new NotFoundException(UserExceptionsMessages.NOT_FOUND.message));
    }
}
