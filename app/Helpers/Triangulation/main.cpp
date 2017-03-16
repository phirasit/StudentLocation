/*

Triangulation helper

Because php is too slow.

This programs receives the position of each fixed point and length to the required position.
It then compute the most likely position and print on stdout. 

INPUT: n d (P11, P12, ..., P1d, t1, l1) ... (Pn1, Pn2, ..., Pnd, tn, ln) (p1, p2, ..., pd starting coordinate)
OUTPUT: (x1, x2, ..., xd) the most likely point
*/

#include <cmath>
#include <iostream>
#include <vector>

const int NUMBER_OF_ITERATION = 100000;
const int alpha = 10;
const double learningRate = 0.0001;

typedef std::vector<double> point;

class Location {
	public:
		point position;
		int t;
		double length;
		double coef, rem_const;

		void init(int max_t) {
			// coef = exp((double) (t - max_t) / alpha) + 1.0;
			coef = 2.0;
		}

		void calcGradConst(point& q) {
			double val = 0.0;
			for (int i = 0 ; i < (int)position.size() ; ++i) {
				val += pow(q[i] - position[i], 2);
			}
			val -= length * length;
			rem_const = (coef * pow(val, coef-1.0));
		}

		double gradience(point& q, int idx) const {
			return rem_const * (q[idx] - position[idx]);
		}

		Location(int d) : position(d) {}
};

int main(int argc, char* argv[]) {

	if (argc < 3) {
		std::cerr << "read instruction in the source code";
	}

	int argv_cnt = 1;

	const int n = atoi(argv[argv_cnt++]);
	const int d = atoi(argv[argv_cnt++]);

	// parse all input
	std::vector<Location> location(n, Location(d));
	for (auto& loc : location) {
		for (double &x : loc.position) {
			x = atof(argv[argv_cnt++]);
		}
		loc.t = atoi(argv[argv_cnt++]);
		loc.length = atof(argv[argv_cnt++]);
	}

	point pos(d);
	for (double &x : pos) {
		x = atof(argv[argv_cnt++]);
	}

	// check for parsing error
	// for (auto& loc : location) {
	// 	for (double &x : loc.position) {
	// 		std::cerr << x << " ";
	// 	}
	// 	std::cerr << loc.t << " " << loc.length << std::endl;
	// }

	// compute answer by using linear regression
	/*

	coef = e ^ ((T - maxT) / alpha)
	D = 1/n * sum( (dx^2 + dy^2 + dz^2 - l^2) ^ 2 )
	dD/dx = 1/n * sum( coef * (dx^2 + dy^2 + dz^2 - l^2) ^ (coef-1) * 2 * (x-lx))
	
	*/

	double mxDIS = 0.0;
	int maxT = 0;
	for (auto& loc : location) {
		maxT = std::max(maxT, loc.t);
		for (double x : loc.position) {
			mxDIS = std::max(mxDIS, x);
		}
	}

	for (auto& loc : location) {
		loc.init(maxT);
	}


	std::vector<double> prevGradiences(d, 0);
	for (int iter = 1 ; iter <= NUMBER_OF_ITERATION ; ++iter) {

		for (int i = 0 ; i < n ; ++i) {
			location[i].calcGradConst(pos);
		}

		std::vector<double> gradiences(d, 0);
		for (int j = 0 ; j < d ; ++j) {
			double &grad = gradiences[j];
			for (int i = 0 ; i < n ; ++i) {
				grad += location[i].gradience(pos, j);
			}
			grad /= n;
		}

		// update position
		// double rate = 1.0 / iter * mxDIS;
		double rate = learningRate;
		double momentum = 0.0001;
		for (int j = 0 ; j < d ; ++j) {
			pos[j] -= rate * gradiences[j] + momentum * prevGradiences[j];
		}

		for (int j = 0 ; j < d and iter + 10 >  NUMBER_OF_ITERATION ; ++j) {
			std::cerr << gradiences[j] << "[" << pos[j] << "]";
			if (j == d-1) std::cerr << std::endl;
		}

		for (int j = 0 ; j < d ; ++j) {
			prevGradiences[j] = 0.3 * prevGradiences[j] + 0.7 * gradiences[j];
		}
	}

	// report output
	for (double x : pos) {
		std::cout << x << " ";
	}
	std::cout << std::endl;

	// std::cerr << "###########" << std::endl;
	// double D = 0;
	// for (auto& loc : location) {
	// 	double len = 0.0;
	// 	for (int i = 0 ; i < d ; ++i) {
	// 		std::cerr << loc.position[i] << " ";
	// 		len += pow(loc.position[i] - pos[i], 2);
	// 	}
	// 	std::cerr << loc.t << " " << loc.length << " # " << sqrt(len) << std::endl;
	// 	D += pow(len - pow(loc.length, 2), loc.coef);
	// }

	// std::cerr << D << std::endl;

	return 0;
}