class UsersController < ApplicationController
  before_action :set_user, only: [:destroy, :show, :update]

  def create
    if User.create!(user_params)
      render json: {'message': "User was successfully created!" }, status: :created
    end
  end

  def destroy
    if @user.destroy!
      render json: {'message': "User was successfully destroyed!" }, status: :no_content
    end
  end

  def show
    render json: @user, status: :ok
  end

  def update
    if @user.update!(user_params)
      render json: {'message': "User was successfully updated!" }, status: :ok
    end
  end

  private

  def user_params
    params.require(:user).permit(:name, :email, :ssn, :password_digest, :kind)
  end

  def set_user
    @user = User.find(params[:id])
  end
end
