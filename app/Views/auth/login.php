<?php $this->extend('layouts.auth'); ?>

<div class="login-container-text">
  <p class="login-title">Welcome Back!</p>
  <p class="login-subtitle">Login in to continue connecting to your community</p>
</div>

<div class="login-container-form">
  <form action="/login" method="POST">
    <?= csrf_field() ?>

    <label for="email" class="field-label">Email Or Handle</label>
    <div class="field-container">
      <i class="fa-solid fa-envelope field-icon"></i>
      <input
        type="email"
        id="email"
        name="email"
        value="<?= e(old('email')) ?>"
        placeholder="Enter your email or handle"
        class="field-input"
        required
      />
    </div>

    <label for="password" class="field-label">Password</label>
    <div class="field-container">
      <i class="fa-solid fa-lock field-icon"></i>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="Enter your password"
        class="field-input"
        required
      />
    </div>

    <div class="login-options">
      <label class="checkbox-container">
        <input type="checkbox" name="remember" class="login-checkbox" />
        <span class="custom-checkbox"></span>
        Remember me
      </label>
      <a href="#" class="login-link">Forgot Password?</a>
    </div>

    <div class="login-options">
      <a href="/signup" class="login-link">Create an account</a>
    </div>

    <button type="submit" class="login-button">Login</button>
  </form>
</div>
