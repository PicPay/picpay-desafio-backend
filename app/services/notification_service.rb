class NotificationService
  def initialize
    def call
      begin
        RestClient.get 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6'
      rescue RestClient::ExceptionWithResponse => e
        render json: { 'message': e.response.to_s }, status: :bad_request
      end
    end
  end
end
