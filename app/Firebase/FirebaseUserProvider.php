<?php
namespace App\Firebase;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\User;

class FirebaseUserProvider implements UserProvider {
  protected $hasher;
  protected $model;
  protected $auth;
  protected $firestoreUser;
  public function __construct(HasherContract $hasher, $model) {
    $this->model = $model;
    $this->hasher = $hasher;
    $this->auth = app('firebase.auth');
    $this->firestoreUser = app('firebase.firestore')->database();
  }
  public function retrieveById($identifier) {
    $firebaseUser = $this->auth->getUser($identifier);
    $userInfo = $this->firestoreUser->collection('users')->document($firebaseUser->uid)->snapshot()->data();
    $user = new User([
        'localId' => $firebaseUser->uid,
        'email' => $firebaseUser->email,
        'displayName' => $firebaseUser->displayName,
        'name' => $userInfo['fname'],
        'lastname'=> $userInfo['lname'],
        'birthday'=> $userInfo['bday'],
        'created_at' => $userInfo['created_at'],
    ]);
    return $user;
  }
  public function retrieveByToken($identifier, $token) {}
    public function updateRememberToken(UserContract $user, $token) {}
      public function retrieveByCredentials(array $credentials) {}
        public function validateCredentials(UserContract $user, array $credentials) {}
        }
