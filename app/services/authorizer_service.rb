class AuthorizerService
  def call
    begin
      RestClient.get 'http://o4d9z.mocklab.io/notify'
    rescue RestClient::ExceptionWithResponse => e
      render json: { 'message': e.response.to_s }, status: :bad_request
    end
  end
end
