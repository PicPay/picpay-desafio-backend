package com.challenge.picpay.core.services.common;

import com.challenge.picpay.core.repositories.UserRepository;
import com.challenge.picpay.core.services.UserService;
import com.challenge.picpay.domain.models.entities.User;
import jakarta.transaction.Transactional;
import lombok.AllArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Service;

import java.util.UUID;

@AllArgsConstructor

@Service
public class UserServiceImpl implements UserService {

    private UserRepository repository;

    @Override
    public Page<User> getAll(int page, int size) {
        return null;
    }

    @Override
    public User findById(UUID uuid) {
        return null;
    }

    @Transactional
    @Override
    public User save(User user) {
        return null;
    }

    @Transactional
    @Override
    public User update(User user, UUID uuid) {
        return null;
    }

    @Transactional
    @Override
    public void delete(UUID uuid) {

    }
}
